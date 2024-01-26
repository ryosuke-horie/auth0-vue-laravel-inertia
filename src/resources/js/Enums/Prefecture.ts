export const Prefecture = {
    "Hokkaido": {
        "value": 1,
        "name": "北海道"
    },
    "Aomori": {
        "value": 2,
        "name": "青森県"
    },
    "Iwate": {
        "value": 3,
        "name": "岩手県"
    },
    "Miyagi": {
        "value": 4,
        "name": "宮城県"
    },
    "Akita": {
        "value": 5,
        "name": "秋田県"
    },
    "Yamagata": {
        "value": 6,
        "name": "山形県"
    },
    "Fukushima": {
        "value": 7,
        "name": "福島県"
    },
    "Ibaraki": {
        "value": 8,
        "name": "茨城県"
    },
    "Tochigi": {
        "value": 9,
        "name": "栃木県"
    },
    "Gunma": {
        "value": 10,
        "name": "群馬県"
    },
    "Saitama": {
        "value": 11,
        "name": "埼玉県"
    },
    "Chiba": {
        "value": 12,
        "name": "千葉県"
    },
    "Tokyo": {
        "value": 13,
        "name": "東京都"
    },
    "Kanagawa": {
        "value": 14,
        "name": "神奈川県"
    },
    "Niigata": {
        "value": 15,
        "name": "新潟県"
    },
    "Toyama": {
        "value": 16,
        "name": "富山県"
    },
    "Ishikawa": {
        "value": 17,
        "name": "石川県"
    },
    "Fukui": {
        "value": 18,
        "name": "福井県"
    },
    "Yamanashi": {
        "value": 19,
        "name": "山梨県"
    },
    "Nagano": {
        "value": 20,
        "name": "長野県"
    },
    "Gifu": {
        "value": 21,
        "name": "岐阜県"
    },
    "Shizuoka": {
        "value": 22,
        "name": "静岡県"
    },
    "Aichi": {
        "value": 23,
        "name": "愛知県"
    },
    "Mie": {
        "value": 24,
        "name": "三重県"
    },
    "Shiga": {
        "value": 25,
        "name": "滋賀県"
    },
    "Kyoto": {
        "value": 26,
        "name": "京都府"
    },
    "Osaka": {
        "value": 27,
        "name": "大阪府"
    },
    "Hyogo": {
        "value": 28,
        "name": "兵庫県"
    },
    "Nara": {
        "value": 29,
        "name": "奈良県"
    },
    "Wakayama": {
        "value": 30,
        "name": "和歌山県"
    },
    "Tottori": {
        "value": 31,
        "name": "鳥取県"
    },
    "Shimane": {
        "value": 32,
        "name": "島根県"
    },
    "Okayama": {
        "value": 33,
        "name": "岡山県"
    },
    "Hiroshima": {
        "value": 34,
        "name": "広島県"
    },
    "Yamaguchi": {
        "value": 35,
        "name": "山口県"
    },
    "Tokushima": {
        "value": 36,
        "name": "徳島県"
    },
    "Kagawa": {
        "value": 37,
        "name": "香川県"
    },
    "Ehime": {
        "value": 38,
        "name": "愛媛県"
    },
    "Kochi": {
        "value": 39,
        "name": "高知県"
    },
    "Fukuoka": {
        "value": 40,
        "name": "福岡県"
    },
    "Saga": {
        "value": 41,
        "name": "佐賀県"
    },
    "Nagasaki": {
        "value": 42,
        "name": "長崎県"
    },
    "Kumamoto": {
        "value": 43,
        "name": "熊本県"
    },
    "Oita": {
        "value": 44,
        "name": "大分県"
    },
    "Miyazaki": {
        "value": 45,
        "name": "宮崎県"
    },
    "Kagoshima": {
        "value": 46,
        "name": "鹿児島県"
    },
    "Okinawa": {
        "value": 47,
        "name": "沖縄県"
    },
} as const;

export type Prefecture= typeof Prefecture[keyof typeof Prefecture];
