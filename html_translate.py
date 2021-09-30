from bs4 import BeautifulSoup
import datetime import date

class HtmlProcessor:
    def __init__(self):
        self.html = """"""
        self.load()

        self.today = date.today()

        self.soup = BeautifulSoup(self.html, 'html.parser')
        print(self.soup.title)

    def load(self):
        with open('out.html', 'r') as f:
            self.html = f.read()


