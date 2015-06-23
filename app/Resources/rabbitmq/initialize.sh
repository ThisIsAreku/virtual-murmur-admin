#!/bin/bash

echo "# Preparing vhost"
rabbitmqctl add_vhost vma
if [ "$1" == "--dev" ];
then
    rabbitmqctl set_permissions -p vma guest ".*" ".*" ".*"
fi

echo "# Enable rabbitmq_management plugin"
rabbitmq-plugins enable rabbitmq_management


rabbitmqadmin declare exchange name='text_message' type=topic auto_delete=false durable=true --vhost=kw
rabbitmqadmin declare exchange name='error' type=topic auto_delete=false durable=true --vhost=kw


rabbitmqadmin declare queue name='text_message.channel' auto_delete=false durable=true --vhost=kw arguments='{"x-dead-letter-exchange": "error"}'
rabbitmqadmin declare queue name='text_message.user' auto_delete=false durable=true --vhost=kw arguments='{"x-dead-letter-exchange": "error"}'
rabbitmqadmin declare queue name='text_message.requeue' auto_delete=false durable=true --vhost=kw arguments='{"x-dead-letter-exchange": "text_message", "x-message-ttl": 300000}'

echo "# Declaring binding"
rabbitmqadmin declare binding source='error' routing_key='text_message.*' destination='text_message.requeue' --vhost=kw

echo "## Event"
rabbitmqadmin declare binding source='text_message' routing_key='channel' destination='text_message.channel' --vhost=kw
rabbitmqadmin declare binding source='text_message' routing_key='user' destination='text_message.user' --vhost=kw
