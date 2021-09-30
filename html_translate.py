from bs4 import BeautifulSoup
from datetime import date

class HtmlProcessor:
    def __init__(self):
        self.html = """"""
        self.load()

        self.today = date.today()

        self.soup = BeautifulSoup(self.html, 'html.parser')
        print(self.soup.title)
        # print(self.soup.findAll('tr'))
        table_data = self.soup.find_all('table')

        for item in table_data:
            print(item.prettify())

    def load(self):
        with open('out.html', 'r') as f:
            self.html = f.read()


