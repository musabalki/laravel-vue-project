export default {
    data() {
        return {
           
        }
    },
    methods: {
        callApi(method,url,dataObj) {
            try {
                return axios({
                    method: method,
                    url: url,
                    data: dataObj
                });
            } catch (error) {
                return error.response
            }
        },
        i (desc,title="Hey") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        s (desc,title="Great") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        w(desc,title="Oops!") {
            this.$Notice.warning({
                title: title,
                desc: desc   
            });
        },
        e(desc,title="Hey") {
            this.$Notice.error({
                title: title,
                desc: desc
             });
        },
        swr (desc='something went wrong! Please try again',title="Oops!") {
            this.$Notice.error({
                title: title,
                desc: desc
             });
        }
    }
}