/**
 * セッションストレージからデータを取得
 */
export const getSessionStorage = (key: string): string | null => {
  return window.sessionStorage.getItem(key);
};

/**
 * セッションストレージにデータを保存
 */
export const setSessionStorage = (key: string, value: string): void => {
  return window.sessionStorage.setItem(key, value);
};

/**
 * セッションストレージのデータを削除
 */
export const deleteSessionStorage = (key: string): void => {
  window.sessionStorage.removeItem(key);
};
