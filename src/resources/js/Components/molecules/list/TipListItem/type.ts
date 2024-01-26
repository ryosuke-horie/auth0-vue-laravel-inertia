export type TipListItemProps = {
  type?: 'staff' | 'user';
  href: string;
  isRead?: boolean;
  isReponse?: boolean;
  point: number;
  name: string;
  src: string;
  date: string;
};
