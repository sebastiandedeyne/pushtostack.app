import * as React from "react";
import { Stack, Tag } from "../index.d";

type Props = {
  stacks: Stack[];
  onStackClick: (stack: Stack) => void;
  onTagClick: (stack: Stack, tag: Tag) => void;
  className?: string;
};

export default function StackList({ stacks, onStackClick, onTagClick, className }: Props) {
  return (
    <ul className={className}>
      {stacks.map(stack => (
        <li key={stack.uuid}>
          <a href="#" className="flex items-center py-1 mb-1" onClick={() => onStackClick(stack)}>
            <i className="fa fa-layer-group w-6 mt-px text-gray-400 text-xs" />
            <span className="font-medium text-sm text-gray-800">{stack.name}</span>{" "}
            <span className="text-xs text-gray-500 ml-2 mt-1">{stack.link_count}</span>
          </a>
          {stack.tags.length ? (
            <ul className="ml-6">
              {stack.tags.map(tag => (
                <li key={tag.name}>
                  <a
                    href="#"
                    className="flex items-center py-1 mb-1"
                    onClick={() => onTagClick(stack, tag)}
                  >
                    <i className="fa fa-hashtag w-5 mt-px text-gray-400 text-xs" />
                    <span className="font-medium text-sm text-gray-800">{tag.name}</span>{" "}
                    <span className="text-xs text-gray-500 ml-2 mt-1">{tag.link_count}</span>
                  </a>
                </li>
              ))}
            </ul>
          ) : null}
        </li>
      ))}
    </ul>
  );
}
