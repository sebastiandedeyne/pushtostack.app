import { Link } from "./index.d";

type Method = "GET" | "POST" | "DELETE";

async function request(method: Method, url: string, data: {} | null = null) {
  const response = await fetch(url, {
    method,
    body: data ? JSON.stringify(data) : null,
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json, text-plain, */*",
      "X-Requested-With": "XMLHttpRequest"
    }
  });

  if (response.status !== 200) {
    throw new Error();
  }

  return response;
}

export async function search(query: string): Promise<Array<Link>> {
  const response = await request("GET", `/api/links?filter[search]=${query}`);
  const { data } = await response.json();

  return data;
}

export async function createLink(url: string, stackUuid: string): Promise<Link> {
  const response = await request("POST", "/api/links", { url, stack_uuid: stackUuid });

  return await response.json();
}

export function deleteLink(linkUuid: string) {
  return request("DELETE", `/api/links/${linkUuid}`);
}
