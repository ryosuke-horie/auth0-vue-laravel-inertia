export const PointListItemCategoryProp = {
  exchange: 1,
  get: 2,
} as const;

export type PointListItemCategoryProp = (typeof PointListItemCategoryProp)[keyof typeof PointListItemCategoryProp];

export type PointListItemProps = {
  category: PointListItemCategoryProp;
  isExpired?: boolean;
  count: number;
  date: string;
};
