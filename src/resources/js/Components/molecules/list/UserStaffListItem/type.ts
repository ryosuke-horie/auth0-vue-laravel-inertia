export type UserStaffListItemProps = {
  href: string;
  staffId: number;
  staff: { todayShiftStatus: number };
  favoriteId: number | null;
  staffName: string;
  todayShiftStatus: number;
  images: { image: string; order: number }[];
};
