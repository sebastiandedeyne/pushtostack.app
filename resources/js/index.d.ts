export type Stack = {
  uuid: string;
  name: string;
  slug: string;
  order: number;
  link_count: number;
  tags: Array<
    Tag & {
      link_count: number;
    }
  >;
};

export type Tag = {
  name: string;
  slug: string;
};

export type Link = {
  uuid: string;
  url: string;
  host: string;
  title: string;
  favicon_url: string | null;
  added_at: string;
};
