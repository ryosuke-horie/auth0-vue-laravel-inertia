export type FavoriteStaffListItemPorps = {
  staffId?: number;
  businessId?: number;
  staffProfileImages: { image: string; order: number }[];
  staffName: string;
  businessName: string;
  href: string;
};
