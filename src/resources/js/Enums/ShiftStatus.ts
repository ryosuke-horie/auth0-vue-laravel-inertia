export const ShiftStatus = {
    "Working": {
        "value": 1,
        "name": "出勤"
    },
    "Off": {
        "value": 2,
        "name": "休み"
    },
    "Undecided": {
        "value": 3,
        "name": "未定"
    },
} as const;

export type ShiftStatus= typeof ShiftStatus[keyof typeof ShiftStatus];
