import * as React from "react";
import { useEffect, useState } from "react";
import { Link } from "../index.d";
import * as api from "../api";

type Props = {
  query: string;
};

export default function Links({ query }: Props) {
  const [links, setLinks] = useState<Array<Link>>([]);

  useEffect(() => {
    if (!query) {
      setLinks([]);
      return;
    }

    api.search(query).then(links => {
      setLinks(links);
    });
  }, [query]);

  return (
    <ul>
      {links.map(link => (
        <li key={link.uuid} className="flex py-3">
          {link.favicon_url ? (
            <img
              src={link.favicon_url}
              alt={`Favicon for ${link.title}`}
              className="block w-5 h-5 rounded mt-1"
            />
          ) : (
            <span className="block w-5 h-5" />
          )}
          <div className="ml-4">
            <a
              href={link.url}
              target="_blank"
              rel="nofollow"
              className="font-medium text-gray-900 leading-tight"
            >
              {link.title}
            </a>
            <p className="text-gray-500 text-sm">
              <a href={link.url} target="_blank" rel="nofollow">
                {link.host}
              </a>
            </p>
          </div>
        </li>
      ))}
    </ul>
  );
}
