import * as React from "react";
import { Fragment } from "react";
import { Stack } from "../index.d";
import StackIndexItem from "./StackIndexItem";

type Props = {
  stacks: Stack[];
  active: string;
  onStackClick: (stackUuid: string) => void;
};

export default function StackIndex({ stacks, active, onStackClick }: Props) {
  const parentStacks = stacks
    .filter(stack => stack.parent_uuid === null)
    .map(stack => ({
      ...stack,
      children: stacks.filter(child => child.parent_uuid === stack.uuid)
    }));

  return (
    <>
      <ul className="mt-12">
        {parentStacks.map(stack => (
          <Fragment key={stack.uuid}>
            <StackIndexItem
              key={stack.uuid}
              onClick={() => onStackClick(stack.uuid)}
              isActive={stack.uuid === active}
              {...stack}
            />
            {stack.children.map(stack => (
              <StackIndexItem
                key={stack.uuid}
                onClick={() => onStackClick(stack.uuid)}
                isActive={stack.uuid === active}
                isSubStack
                {...stack}
              />
            ))}
          </Fragment>
        ))}
      </ul>
    </>
  );
}
