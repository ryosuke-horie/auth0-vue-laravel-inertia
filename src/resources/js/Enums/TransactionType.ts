export const TransactionType = {
    "exChange": 1,
    "get": 2,
} as const;

export type TransactionType= typeof TransactionType[keyof typeof TransactionType];
