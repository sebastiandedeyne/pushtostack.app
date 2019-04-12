import * as React from "react";
import { useState, useEffect, useRef } from "react";
import { Stack, Tag } from "../index.d";
import StackList from "./StackList";
import TagList from "./TagList";
import Links from "./Links";

type Props = {
  userUuid: string;
  stacks: Array<Stack>;
  tags: Array<Tag>;
};

export default function App({ stacks, tags }: Props) {
  const [query, setQuery] = useState("in:inbox");

  const searchRef = useRef<HTMLInputElement>(null);

  useEffect(() => {
    window.addEventListener("keyup", e => {
      if (e.key !== "/") {
        return;
      }

      if (document.activeElement === searchRef.current) {
        return;
      }

      (searchRef.current as HTMLInputElement).focus();
    });
  }, []);

  return (
    <div className="p-6 mx-auto max-w-6xl w-full flex">
      <nav className="w-48 mt-16 sticky top-0">
        <StackList
          stacks={stacks}
          onStackClick={stack => setQuery(`in:${stack.slug}`)}
          className="mb-8"
        />
        <TagList
          tags={tags}
          onTagClick={tag => setQuery(`#${tag.slug}`)}
          onTagShiftClick={tag => setQuery(`${query} #${tag.slug}`.trim())}
          className="mb-8"
        />
        <ul>
          <li className="py-1 mb-1">
            <i className="fa fa-rss w-6 mt-px text-gray-400 text-xs" />
            <span className="font-medium text-sm text-gray-800">Feeds</span>
          </li>
          <li className="py-1 mb-1">
            <i className="fa fa-cog w-6 mt-px text-gray-400 text-xs" />
            <span className="font-medium text-sm text-gray-800">Settings</span>
          </li>
          <li className="py-1 mb-1">
            <i className="fa fa-running w-6 mt-px text-gray-400 text-xs" />
            <span className="font-medium text-sm text-gray-800">Log out</span>
          </li>
        </ul>
      </nav>
      <div className="flex-1 mx-8">
        <div className="max-w-4xl">
          <input
            ref={searchRef}
            type="search"
            value={query}
            placeholder="Search..."
            onChange={e => setQuery(e.target.value)}
            className="w-full py-1 border-b focus:outline-none focus:border-gray-400 mb-6 rounded-none appearance-none"
          />
          <Links query={query} />
        </div>
      </div>
      <div className="hidden xl:block w-48" />
    </div>
  );
}
