import re
import os

# parse the config file.
lines = file('/home/grapeot/rss2page/data.txt', 'r').readlines()
for l in lines:
    fields = l.split(',')
    accessToken = fields[0]
    pageId = fields[1]
    rssPage = fields[2]
    os.system('mv %s old_%s' % (pageId, pageId))
    os.system('curl "%s" -o %s' % (rssPage, pageId))
    os.system('diff %s old_%s | grep "^<" > diff.txt' % (pageId, pageId))
    for content in re.split('<entry>', file('diff.txt', 'r').read()):
    	if re.search('<title>', content) is None: continue
    	title = re.search('<title>(.*)</title>', content).groups()[0]
    	link = re.search('<link href="(.*?)"', content).groups()[0]
    	message = re.search(' border-color : #e7d796;margin-bottom : 1em; color : #9a8c59;">Article note: (.*)</div>', content)
    	if message is None:
    		os.system('curl -d "access_token=%s&link=%s" https://graph.facebook.com/%s/feed ' % (accessToken, link, pageId))
    	else:
    		os.system('curl -d "access_token=%s&link=%s&message=%s" https://graph.facebook.com/%s/feed ' % (accessToken, link, message.groups()[0], pageId))
    		
