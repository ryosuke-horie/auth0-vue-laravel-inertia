export const RequestStatus = {
    "Transferred": {
        "value": 1,
        "name": "振込済み"
    },
    "Pending": {
        "value": 2,
        "name": "未振込"
    },
    "Cancel": {
        "value": 3,
        "name": "キャンセル"
    },
} as const;

export type RequestStatus= typeof RequestStatus[keyof typeof RequestStatus];
