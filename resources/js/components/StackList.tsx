import * as React from "react";
import { Stack } from "..";

type Props = {
  stacks: Stack[];
  onStackClick: (stack: Stack) => void;
  className?: string;
};

export default function StackList({ stacks, onStackClick, className }: Props) {
  return (
    <ul className={className}>
      {stacks.map(stack => (
        <li key={stack.uuid}>
          <a href="#" className="flex items-center py-1 mb-1" onClick={() => onStackClick(stack)}>
            <i className="fa fa-layer-group w-6 mt-px text-gray-400 text-xs" />
            <span className="font-medium text-sm text-gray-800">{stack.name}</span>{" "}
            <span className="text-xs text-gray-500 ml-2 mt-1">{stack.link_count}</span>
          </a>
        </li>
      ))}
    </ul>
  );
}
