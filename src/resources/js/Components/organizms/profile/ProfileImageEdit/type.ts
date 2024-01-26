import { OrderEnum } from '@/api';

export type ProfileImageEditImageProp = {
  src?: string;
  alt?: string;
  order: OrderEnum;
};

export type ProfileImageEditProps = {
  images: ProfileImageEditImageProp[];
};
