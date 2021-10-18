from bs4 import BeautifulSoup
from datetime import date

class HtmlProcessor:
    def __init__(self):
        self.html = """"""
        self.load()
        self.today = date.today()
        self.save()

        self.soup = BeautifulSoup(self.html, 'html.parser')
        print(self.soup.title)

        # print(self.soup.findAll('tr'))
        table_data = self.soup.find_all('table')

        x=0

        for item in table_data:
            x +=1
            for td in item:
                print(td)
        # print(item.prettify())

    def load(self):
        with open('out.html', 'r') as f:
            self.html = f.read()

    def save(self):
        with open('nest.html', 'w') as f:
            f.write(self.html)




