/**
 * データの存在判定
 */
export const exists = (value: unknown): boolean => {
  if (value === undefined) {
    return false;
  }

  if (value === null) {
    return false;
  }

  if (value === '') {
    return false;
  }

  if (typeof value === 'object') {
    if (Object.keys(value).length === 0) {
      return false;
    }
  }

  if (Array.isArray(value)) {
    if (value.length === 0) {
      return false;
    }
  }

  return true;
};
