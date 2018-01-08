#!/usr/bin/env python
import boto3
from collections import defaultdict
import paramiko
import time
import pdb
import sys
import os

"""if len(sys.argv) < 2:
    print "usage: {0} <function> [arguments]"
    sys.exit(1)



MAX_COUNT = int(sys.argv[1])
print "Creating %s instances" %MAX_COUNT
ec2 = boto3.resource('ec2', region_name='us-west-2', aws_access_key_id='AKIAJFOXIWAFEGXUAYXA', aws_secret_access_key='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')
instance = ec2.create_instances(
    ImageId='ami-2ee73856',
    MinCount=1,
    MaxCount=MAX_COUNT,
    KeyName="mykey",
    SecurityGroupIds=['sg-b2b6a1cf'],
    InstanceType='t2.micro')
#var1 = instance[0].id
#print dir(var1)
"""
client = boto3.client('ec2')
#waiter = client.get_waiter('instance_status_ok')
#waiter.wait(InstanceIds= [instance[0].id, instance[1].id])
#time.sleep(300)
print "All instances are up and running"
running_instances = ec2.instances.filter(Filters=[{
'Name': 'instance-state-name',
'Values': ['running']}])
print running_instances
from boto.manage.cmdshell import sshclient_from_instance
ec2info = defaultdict()
for instance in running_instances:
    print "*****"
    print instance.tags
# Add instance info to a dictionary 
    ec2info[instance.id] = {
    'Type': instance.instance_type,
    'State': instance.state['Name'],
    'Private IP': instance.private_ip_address,
    'Public IP': instance.public_ip_address,
    'Launch Time': instance.launch_time,
    'Public DNS': instance.public_dns_name
    }

attributes = ['Type', 'State', 'Private IP', 'Public IP', 'Launch Time', 'Public DNS']
for instance_id, instance in ec2info.items():
    for key in attributes:
        print("{0}: {1}".format(key, instance[key]))
    print("------")
for ec2_inst in running_instances:
    public_ip = ec2info[ec2_inst.id].get('Public IP')
        #print ec2info[var1].get('Public IP')
    if public_ip != '54.245.35.20' and public_ip != '54.149.179.42':
        url = ec2info[ec2_inst.id].get('Public DNS')
        new_url = "http://"+url
        print "Instance_ID/IP: {}/{}".format(ec2_inst.id, public_ip)
        print "Copying OSSN files to the instance Id/IP {}/{}".format(ec2_inst.id, public_ip)
        new_public_ip = public_ip.replace(".","-")
        os.system("rsync -avz -e \"ssh -o stricthostkeychecking=no -o userknownhostsfile=/dev/null -i /home/ec2-user/smartnet/mykey.pem\" /home/ec2-user/smartnet/ossn.config.json ubuntu@ec2-"+new_public_ip+".us-west-2.compute.amazonaws.com:")
        os.system("ssh -o stricthostkeychecking=no -o userknownhostsfile=/dev/null ubuntu@ec2-"+new_public_ip+".us-west-2.compute.amazonaws.com -i /home/ec2-user/smartnet/mykey.pem 'sudo cp /home/ubuntu/ossn.config.json /var/www/html/DMSN/installation && sudo chown 33:33 /var/www/html/DMSN/installation/ossn.config.json'")
        print "Transfer Complete"
