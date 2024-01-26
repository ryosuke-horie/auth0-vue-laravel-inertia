export const MessageFileButtonPreviewProp = {
  Image: 'image',
  Video: 'video',
} as const;

export type MessageFileButtonPreviewProp =
  (typeof MessageFileButtonPreviewProp)[keyof typeof MessageFileButtonPreviewProp];

export type MessageFileButtonProps = {
  previewType: MessageFileButtonPreviewProp | null;
  previewSrc: string | null;
};
