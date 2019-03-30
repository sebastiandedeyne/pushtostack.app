import * as React from "react";
import { useState } from "react";
import { useStackChangesForUser } from "../echo";
import { Stack } from "../index.d";
import StackIndex from "./StackIndex";
import StackDetail from "./StackDetail";

type Props = {
  userUuid: string;
  stacks: Array<Stack>;
};

export default function App({ stacks: initialStacks, userUuid }: Props) {
  const [stacks, setStacks] = useState(initialStacks);
  const [activeStackUuid, setActiveStackUuid] = useState(initialStacks[0].uuid);

  useStackChangesForUser(userUuid, (updatedStack: Stack) => {
    setStacks(stacks => {
      return stacks.map(stack => {
        if (stack.uuid === updatedStack.uuid) {
          return updatedStack;
        }

        return stack;
      });
    });
  });

  function incrementActiveStackLinkCount() {
    setStacks(stacks => {
      return stacks.map(stack => {
        if (stack.uuid === activeStackUuid) {
          return { ...stack, link_count: stack.link_count + 1 };
        }

        return stack;
      });
    });
  }

  function decrementActiveStackLinkCount() {
    setStacks(stacks => {
      return stacks.map(stack => {
        if (stack.uuid === activeStackUuid) {
          return { ...stack, link_count: stack.link_count - 1 };
        }

        return stack;
      });
    });
  }

  return (
    <div className="w-full h-screen flex">
      <nav className="w-1/5 bg-gray-100 border-r border-gray-200 py-3 px-3">
        <StackIndex stacks={stacks} active={activeStackUuid} onStackClick={setActiveStackUuid} />
      </nav>
      <div className="flex-1 py-2">
        <StackDetail
          stackUuid={activeStackUuid}
          onLinkAdded={incrementActiveStackLinkCount}
          onLinkDeleted={decrementActiveStackLinkCount}
        />
      </div>
    </div>
  );
}
