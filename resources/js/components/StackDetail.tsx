import * as React from "react";
import { useEffect, useState } from "react";
import { Stack, Link } from "../index.d";
import { useLinkChangesInStack } from "../echo";
import * as api from "../api";

type Props = {
  stackUuid: string;
  onLinkAdded: () => void;
  onLinkDeleted: () => void;
};

export default function Stack({ stackUuid, onLinkAdded, onLinkDeleted }: Props) {
  const [links, setLinks] = useState<Array<Link>>([]);
  const [newLink, setNewLink] = useState("");

  useEffect(() => {
    api.getLinks(stackUuid).then(links => {
      setLinks(links);
    });
  }, [stackUuid]);

  useLinkChangesInStack(stackUuid, (updatedLink: Link) => {
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
    api.createLink(newLink, stackUuid).then(link => {
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
    <ul>
      <li>
        <form className="w-full flex pl-6 py-2" onSubmit={e => (e.preventDefault(), saveLink())}>
          <span
            className="w-5 h-5 bg-gray-300 rounded mr-3"
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
      </li>
      {links.map(link => (
        <li key={link.uuid} className="flex">
          <a
            className="flex-1 flex items-center pl-6 py-2"
            href={link.url}
            target="_blank"
            rel="nofollow"
          >
            {link.favicon_url ? (
              <img
                src={link.favicon_url}
                alt={`Favicon for ${link.title}`}
                className="inline-block w-5 h-5 rounded mr-3"
              />
            ) : (
              <span className="inline-block w-5 h-5 bg-gray-300 rounded mr-3" />
            )}
            <span className="font-medium text-gray-900">{link.title}</span>{" "}
            <span className="inline-block text-gray-600">&nbsp;–&nbsp;{link.host}</span>
          </a>
          <button onClick={() => deleteLink(link.uuid)}>Delete</button>
        </li>
      ))}
    </ul>
  );
}
