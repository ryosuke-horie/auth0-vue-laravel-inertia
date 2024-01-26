export const ApplicationStatus = {
    "Review": {
        "value": 1,
        "name": "審査中"
    },
    "Approval": {
        "value": 2,
        "name": "許可"
    },
    "Denial": {
        "value": 3,
        "name": "否認"
    },
} as const;

export type ApplicationStatus= typeof ApplicationStatus[keyof typeof ApplicationStatus];
