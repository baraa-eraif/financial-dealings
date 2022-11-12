import { initializeApp } from "firebase/app"
import { getFirestore } from "firebase/firestore"
import { getStorage, ref } from "firebase/storage";
import { getMessaging } from "firebase/messaging/sw";


export const firebaseConfig = {
    apiKey: "AIzaSyCxLKg8ClSkXwGtJ5nZrBnZtcN-4E2zwk8",
    authDomain: "goglob-b9562.firebaseapp.com",
    projectId: "goglob-b9562",
    storageBucket: "goglob-b9562.appspot.com",
    messagingSenderId: "229890063420",
    appId: "1:229890063420:web:b9043ccc0117e98a2a1739",
    measurementId: "G-H8LQLJ9SDV",
    server_key: "AAAANYaD_Dw:APA91bE9eebrgvhDwgCmZXnpQqotFrXcAp5_KgAT4g-vlCcn8rktjLVTpc8PmeXc37WMx7UOiZoBgGKsxYCU85O9Qdjl2vCTLsXVflp3q1csL361BsvCyAfk8eRTIjkozHvn5D3n1PX6"
}

const firebaseApp = initializeApp(firebaseConfig);

export const db = getFirestore();
export const messaging = getMessaging();

