export const StaffMessageListItemMessageSrcType = {
  Image: 'image',
  Video: 'video',
} as const;

export type StaffMessageListItemMessageSrcType =
  (typeof StaffMessageListItemMessageSrcType)[keyof typeof StaffMessageListItemMessageSrcType];

export type StaffMessageListItemProps = {
  date: string;
  src: string;
  message: string;
  messageSrc?: string;
  messageSrcType?: StaffMessageListItemMessageSrcType;
};
