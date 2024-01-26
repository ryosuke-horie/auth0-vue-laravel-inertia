interface ImportMeta {
  // globメソッドの型定義
  glob(pattern: string): Record<string, () => Promise<{ [key: string]: any }>>;
}
