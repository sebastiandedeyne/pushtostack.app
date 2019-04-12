import * as React from "react";
import { Tag } from "../index.d";

type Props = {
  tags: Tag[];
  onTagClick: (stack: Tag) => void;
  onTagShiftClick: (stack: Tag) => void;
  className?: string;
};

export default function TagList({ tags, onTagClick, onTagShiftClick, className }: Props) {
  return (
    <ul className={className}>
      {tags.map(tag => (
        <li key={tag.uuid}>
          <a
            href="#"
            className="flex items-center py-1 mb-1"
            onClick={e => {
              e.preventDefault();
              (e.shiftKey ? onTagShiftClick : onTagClick)(tag);
            }}
          >
            <i className="fa fa-hashtag w-6 mt-px text-gray-400 text-xs" />
            <span className="font-medium text-sm text-gray-800">{tag.name}</span>{" "}
            <span className="text-xs text-gray-500 ml-2 mt-1">{tag.link_count}</span>
          </a>
        </li>
      ))}
    </ul>
  );
}
