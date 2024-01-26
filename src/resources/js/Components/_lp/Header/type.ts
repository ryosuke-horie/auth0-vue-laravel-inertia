type HeaderMenuItemProp = {
  text: string;
  href: string;
  hrefId?: string;
};

export type HeaderProps = {
  menus: HeaderMenuItemProp[];
};
