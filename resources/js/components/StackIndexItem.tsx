import * as React from "react";
import { Stack } from "../index.d";

type Props = Stack & {
  isActive?: boolean;
  isSubStack?: boolean;
  onClick: () => void;
};

export default function StackIndexItem({
  name,
  link_count,
  isActive = false,
  isSubStack = false,
  onClick
}: Props) {
  return (
    <li>
      <a
        href="#"
        className={`flex items-center py-1 mb-1 rounded ${isSubStack ? "ml-6" : ""} ${
          isActive ? "text-blue-600" : "text-gray-700"
        }`}
        onClick={onClick}
      >
        <i
          className={`${isActive ? "" : "text-gray-400"} ${
            isSubStack ? "fa fa-hashtag w-5" : "fa fa-layer-group w-6"
          }`}
        />
        <span className="font-semibold">{name}</span>{" "}
        <span className="text-xs text-gray-500 ml-2 mt-1">{link_count}</span>
      </a>
    </li>
  );
}
