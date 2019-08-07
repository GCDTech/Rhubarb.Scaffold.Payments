rhubarb.vb.create('AuthenticationCaptureControlViewBridge', function() {
    return {
        attachEvents:function() {
        },
        /**
         * Implemented by a provider to start the customers journey to authenticate a payment.
         * @param paymentEntity
         */
        startCustomerAuthentication: function(paymentEntity){

        }
    };
})