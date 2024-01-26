import { Configuration } from '@/api';

export const configuration: Configuration = new Configuration({
  basePath: `${import.meta.env.VITE_OPENAPI_URL}`,
});
