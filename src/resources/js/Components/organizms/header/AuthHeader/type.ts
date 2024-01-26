import { RouteRoleName } from '@/Utilities';

export type AuthHeaderProps = {
  role: RouteRoleName;
  text: string;
  href?: string;
  params?: { [key: string]: number };
};
