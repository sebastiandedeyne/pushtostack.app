import * as React from "react";
import { render } from "react-dom";
import App from "./components/App";
import { Stack, Tag } from "./index.d";

const container = document.getElementById("app");

if (container) {
  const stacks: Array<Stack> = JSON.parse(container.dataset.stacks as string);
  const tags: Array<Tag> = JSON.parse(container.dataset.tags as string);
  const userUuid: string = container.dataset.userUuid as string;

  render(<App stacks={stacks} tags={tags} userUuid={userUuid} />, container);
}
