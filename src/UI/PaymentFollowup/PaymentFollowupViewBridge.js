rhubarb.vb.create('PaymentFollowupViewBridge', function() {
    return {
        onReady:function() {
            this.viewNode.querySelector('.js-continue').addEventListener('click', function(event){
                event.target.classList.add('+processing');
                this.raiseServerEvent('startCustomerAuthentication',this.model.paymentEntity, function(paymentEntity){
                    if (paymentEntity.status == 'Awaiting Authentication'){
                        this.findChildViewBridge('Authentication').startCustomerAuthentication(paymentEntity)
                            .then(function(paymentEntity){
                                this.raiseServerEvent('paymentAuthenticated', paymentEntity, function(){
                                    event.target.classList.remove('+processing');
                                   this.onPaymentAuthenticated();
                                }.bind(this));
                            }.bind(this),
                            function(){
                                event.target.classList.remove('+processing');
                                this.onPaymentFailed(paymentEntity);
                            }.bind(this));
                    }
                }.bind(this));
                //this.findChildViewBridge('Authentication').startCustomerAuthentication(this.model.paymentEntity);
                event.preventDefault();
            }.bind(this));
        },
        onPaymentFailed: function(paymentEntity){
            this.viewNode.querySelector('.js-authenticate').style.display = 'none';
            this.viewNode.querySelector('.js-failed').style.display = 'block';
        },
        onPaymentAuthenticated: function(paymentEntity){
            this.viewNode.querySelector('.js-authenticate').style.display = 'none';
            this.viewNode.querySelector('.js-success').style.display = 'block';
        }
    };
});