export type Stack = {
  uuid: string;
  parent_uuid: string;
  name: string;
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
