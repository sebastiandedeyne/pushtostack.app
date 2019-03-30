import * as React from "react";
import { render } from "react-dom";
import App from "./components/App";
import { Stack } from "./index.d";

const container = document.getElementById("app");

if (container) {
  const stacks: Array<Stack> = JSON.parse(container.dataset.stacks as string);
  const userUuid: string = container.dataset.userUuid as string;

  render(<App stacks={stacks} userUuid={userUuid} />, container);
}
