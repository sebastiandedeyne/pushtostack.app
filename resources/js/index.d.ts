export type Stack = {
  uuid: string;
  name: string;
  slug: string;
  order: number;
  link_count: number;
};

export type Tag = {
  uuid: string;
  name: string;
  slug: string;
  order: number;
  link_count: number;
};

export type Link = {
  uuid: string;
  url: string;
  host: string;
  title: string;
  favicon_url: string | null;
  added_at: string;
};
