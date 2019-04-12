import * as React from "react";
import { useEffect, useState } from "react";
import { Stack, Link } from "../index.d";
import { useLinkChangesInStack } from "../echo";
import * as api from "../api";

type Props = {
  stack: Stack;
  onLinkAdded: () => void;
  onLinkDeleted: () => void;
};

export default function Stack({ stack, onLinkAdded, onLinkDeleted }: Props) {
  const [links, setLinks] = useState<Array<Link>>([]);
  const [newLink, setNewLink] = useState("");

  useEffect(() => {
    api.getLinks(stack.uuid).then(links => {
      setLinks(links);
    });
  }, [stack.uuid]);

  useLinkChangesInStack(stack.uuid, (updatedLink: Link) => {
    setLinks(links => {
      return links.map(link => {
        if (link.uuid === updatedLink.uuid) {
          return updatedLink;
        }

        return link;
      });
    });
  });

  function saveLink() {
    api.createLink(newLink, stack.uuid).then(link => {
      setLinks([link, ...links]);
      setNewLink("");

      onLinkAdded();
    });
  }

  function deleteLink(linkUuid: string) {
    api.deleteLink(linkUuid).then(() => {
      setLinks(links => {
        return links.filter(link => link.uuid !== linkUuid);
      });

      onLinkDeleted();
    });
  }

  return (
    <>
      <input
        type="search"
        placeholder="Search..."
        className="w-full py-1 mb-4 border-b focus:outline-none focus:border-gray-600"
      />
      <ul>
        {/* <li>
        <form className="w-full flex py-2" onSubmit={e => (e.preventDefault(), saveLink())}>
          {/* <span
            className="w-8 h-8 bg-gray-300 rounded mr-3"
            style={{ transform: "translateY(0.225em)" }}
          />
          <input
            type="text"
            value={newLink}
            onChange={e => setNewLink(e.target.value)}
            className="flex-1 font-medium focus:outline-none"
            style={{ transform: "translateY(0.075em)" }}
            placeholder="Paste an URL..."
          />
        </form>
      </li> */}
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
                </a>{" "}
                | <button onClick={() => deleteLink(link.uuid)}>Delete</button>
              </p>
            </div>
          </li>
        ))}
      </ul>
    </>
  );
}
