export const BusinessStatus = {
    "Up": {
        "value": 1,
        "name": "稼働"
    },
    "Stop": {
        "value": 2,
        "name": "停止"
    },
    "Closed": {
        "value": 3,
        "name": "休業"
    },
} as const;

export type BusinessStatus= typeof BusinessStatus[keyof typeof BusinessStatus];
