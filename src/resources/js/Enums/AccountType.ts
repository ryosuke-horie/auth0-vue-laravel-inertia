export const AccountType = {
    "Normal": {
        "value": 1,
        "name": "普通預金口座"
    },
    "Current": {
        "value": 2,
        "name": "当座預金口座"
    },
} as const;

export type AccountType= typeof AccountType[keyof typeof AccountType];
