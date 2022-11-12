import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/lib/styles/main.sass'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/lib/components'
import * as directives from 'vuetify/lib/directives'
import 'vuetify/styles'

export default createVuetify({
    components,
    directives,
    theme: {
        options: {
            customProperties: true
        },
        themes: {
            light: {
                primary: "#5867dd",
                secondary: "#e8ecfa",
                accent: "#5d78ff",
                error: "#fd397a",
                info: "#2fdbd9",
                success: "#0abb87",
                warning: "#ffa500"
            }
        },
    },
})
