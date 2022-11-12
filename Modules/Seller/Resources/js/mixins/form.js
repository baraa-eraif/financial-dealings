import {mapState} from "vuex";

export default {
    computed: {
        ...mapState({
            form: function (state) {

                return _.get(state, `formForm`, {});
            },

        })
    }
}
