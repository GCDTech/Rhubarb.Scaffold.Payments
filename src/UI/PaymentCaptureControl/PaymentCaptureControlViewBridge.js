rhubarb.vb.create('PaymentCaptureControlViewBridge', function() {
    return {
        attachEvents:function() {

        },

        /**
         * attemptPayment should be implemented by provider specific implementations and
         * should try to confirm and, if necessary, authenticate the customer, ultimately
         * resolving in a success, failure or requires customer end point.
         *
         * If the payment method hasn't yet been created this should call createPaymentMethod()
         * as appropriate
         */
        attemptPayment: function(paymentEntity) {

        },

        /**
         * authenticatePayment should be implemented by provider specific implementations to
         * futher a payment through an SCA type customer authentication journey.
         */
        authenticatePayment: function(paymentEntity) {

        },

        /**
         * onAuthenticationRequired should be called by implementations of the pattern when the
         * provider has created a new payment method.
         */
        onPaymentMethodCreated: function(paymentEntity){

        },

        /**
         * Instead of calling onPaymentConfirmed, onPaymentFailed, onAuthenticationRequired individually
         * an implementor may just call this method when a significant event occurs.
         *
         * @param paymentEntity
         */
        onPaymentEntityStatusUpdated: function(paymentEntity){
            return new Promise(function(resolve, reject) {
                switch (paymentEntity.status) {
                    case 'Success':
                        this.onPaymentConfirmed(paymentEntity);
                        resolve();
                        break;
                    case 'Failed':
                        this.onPaymentFailed(paymentEntity);
                        reject(paymentEntity);
                        break;
                    case 'Awaiting Authentication':
                        this.onAuthenticationRequired(paymentEntity).then(resolve, reject);
                        break;
                }
            }.bind(this));
        },

        /**
         * onAuthenticationRequired should be called by implementations of the pattern when the
         * provider needs customer authentication via 3D secure or similar mechanisms.
         *
         * If the payment is onSession this method will automatically engage the authentication
         * flow.
         *
         * Either way the AuthenticationRequired client event is raised.
         */
        onAuthenticationRequired: function(paymentEntity){
            this.raiseClientEvent('AuthenticationRequired', paymentEntity);

            return new Promise(function(resolve, reject) {
                this.authenticatePayment(paymentEntity).then(
                    function () {
                        this.attemptPayment(paymentEntity).then(resolve, reject);
                    }.bind(this), reject
                );
            }.bind(this));
        },

        /**
         * onPaymentConfirmed should be called by implementations of the pattern when the
         * payment has been confirmed.
         */
        onPaymentConfirmed: function(paymentEntity){
            this.raiseClientEvent('PaymentConfirmed', paymentEntity);
        },

        /**
         * onPaymentConfirmed should be called by implementations of the pattern when the
         * payment has failed.
         */
        onPaymentFailed: function(paymentEntity){
            this.raiseClientEvent('PaymentFailed', paymentEntity);
        }
    };
})