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

  const activeStack = stacks.find(stack => stack.uuid === activeStackUuid);

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
    <div className="p-6 mx-auto max-w-6xl w-full flex">
      <nav className="w-48 text-sm">
        <StackIndex stacks={stacks} active={activeStackUuid} onStackClick={setActiveStackUuid} />
      </nav>
      <div className="flex-1 mx-8">
        <div className="max-w-4xl">
          {activeStack ? (
            <StackDetail
              stack={activeStack}
              onLinkAdded={incrementActiveStackLinkCount}
              onLinkDeleted={decrementActiveStackLinkCount}
            />
          ) : null}
        </div>
      </div>
      <nav className="w-48">
        <ul>
          <li>Feeds</li>
          <li>Settings</li>
          <li>Log out</li>
        </ul>
      </nav>
    </div>
  );
}
