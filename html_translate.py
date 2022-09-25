from bs4 import BeautifulSoup
from datetime import datetime


class HtmlProcessor:
    def __init__(self, htmlFileName):
        # Var declarations:
        self.html = """"""
        self.htmlFileName = htmlFileName + ".html"

        self.load()
        self.soup = BeautifulSoup(self.html, 'html.parser')

        # Insert before the end of the </body>
        self.soup.body.insert(len(self.soup.body.contents), self.customFooterHtml())

        self.html = self.soup.prettify(formatter="html")
        self.save()

    def load(self):
        with open(self.htmlFileName, 'r') as f:
            self.html = f.read()

    def save(self):
        with open('out.html', 'w') as f:
            f.write(self.html)

    def customFooterHtml(self):
        now = datetime.now()
        today = now.strftime("%d/%m/%Y %H:%M:%S")
        customFooter = f"""
        <footer>
        <p style="margin: 0 auto; text-align: center;">Table processed by Markurion(c) Last timetable update: {today} </p>
        </footer> """
        return BeautifulSoup(customFooter, 'html.parser')
