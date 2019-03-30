import { useEffect } from "react";
import Echo from "laravel-echo";
import * as Pusher from "pusher-js";
import { Stack, Link } from "./index.d";

declare global {
  interface Window {
    Pusher: any;
  }
}

window.Pusher = Pusher;

const echo = new Echo({
  broadcaster: "pusher",
  key: "f7082fa522418c67f533",
  cluster: "eu"
});

export function useStackChangesForUser(userUuid: string, callback: (stack: Stack) => void) {
  useEffect(() => {
    const channelName = `stack_changes_for_user_${userUuid}`;

    echo.private(channelName).listen(".stack_updated", callback);

    return () => echo.leaveChannel(channelName);
  }, [userUuid]);
}

export function useLinkChangesInStack(stackUuid: string, callback: (link: Link) => void) {
  useEffect(() => {
    const channelName = `link_changes_in_stack_${stackUuid}`;

    echo.private(channelName).listen(".link_updated", callback);

    return () => echo.leaveChannel(channelName);
  }, [stackUuid]);
}
