import { StaffListItem } from '@/api';

export type ScheduleStaffListButtonProps = {
  isLoading: boolean;
  isOpen: boolean;
  staffId: number;
  staffList: StaffListItem[];
};
