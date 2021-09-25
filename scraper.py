from selenium import webdriver
import os

class TimeTable():
    def __init__(self, course_code):
        self.browser = webdriver.Chrome()
        self.course_code = course_code
        print(f'all ok {self.course_code}')

    def load_page(self):
        # self.driver.get("https://timetable.ait.ie/2122/login.aspx?ReturnUrl=%2f2122%2fdefault.aspx")
        self.browser.get("https://www.wp.pl")
        self.browser.quit()
        print('page_loaded')
        os.system("Pause")