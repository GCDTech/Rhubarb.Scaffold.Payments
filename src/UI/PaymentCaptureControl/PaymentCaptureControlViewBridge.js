rhubarb.vb.create('PaymentCaptureControlViewBridge', function() {
    return {
        attachEvents:function() {

        },

        /**
         * setupPaymentMethod should be implemented by provider specific implementations and
         * should try to capture the payment method and authenticate the customer, ultimately
         * resolving in success or failure.
         */
        setupPaymentMethod: function() {

        },

        /**
         * attemptPayment should be implemented by provider specific implementations and
         * should try to confirm and, if necessary, authenticate the customer, ultimately
         * resolving in a success, failure or requires SCA end goal.
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
        onPaymentMethodCreated: function(setupEntity){
            this.raiseClientEvent('PaymentMethodCreated', setupEntity);
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
                if (paymentEntity.onSession) {
                    this.authenticatePayment(paymentEntity).then(
                        function () {
                            this.attemptPayment(paymentEntity).then(resolve, reject);
                        }.bind(this), reject
                    );
                } else {
                    // As this is an off-session payment the customer is not available to
                    // continue the journey. We reject the promise, and depend on the caller
                    // to inspect the payment entity to realise it's not a failure.
                    reject(paymentEntity);
                }
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
});