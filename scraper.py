import time

from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
from datetime import date

from bs4 import BeautifulSoup
import requests

import os


class TimeTable():
    def __init__(self, course_code):
        self.today = date.today()
        self.browser = webdriver.Chrome()
        self.course_code = course_code
        print(f'all ok {self.course_code}')

    def today_day(self):
        return str(self.today.strftime("%A"))

    def load_page(self):
        # r = requests.get('https://timetable.ait.ie/2122/login.aspx?ReturnUrl=%2f2122%2fdefault.aspx')
        # print(r.text)
        # self.driver.get("https://timetable.ait.ie/2122/login.aspx?ReturnUrl=%2f2122%2fdefault.aspx")

        self.browser.get("https://timetable.ait.ie/2122/login.aspx?ReturnUrl=%2f2122%2fdefault.aspx")
        guestLoginBtn = self.browser.find_element_by_id('bGuestLogin')

        try:
            # Clicks guest login button:
            item = WebDriverWait(self.browser, 10).until(
                EC.presence_of_element_located((By.ID, 'bGuestLogin'))
            )
            item.click()

            # Clicks the student by name
            item = WebDriverWait(self.browser, 10).until(
                EC.presence_of_element_located((By.ID, 'LinkBtn_StudentSetByName'))
            )
            item.click()

            # Select Week t= This week , n= Next week
            select_week = Select(WebDriverWait(self.browser, 10).until(
                EC.presence_of_element_located((By.ID, 'lbWeeks'))
            ))
            # select_week.select_by_value('t')
            select_week.select_by_value('t')

            # Finds the select and selects the proper course
            select_course = Select(WebDriverWait(self.browser, 10).until(
                EC.presence_of_element_located((By.ID, 'dlObject'))
            ))
            select_course.select_by_value('AL_KMOBA_8_1')

            # Finds a day interesting day sorted by numbers 1 Monday etc.
            select_day = Select(WebDriverWait(self.browser, 10).until(
                EC.presence_of_element_located((By.ID, 'lbDays'))
            ))
            select_day.select_by_value('1-5')

            btnClick = WebDriverWait(self.browser, 10).until(
                EC.presence_of_element_located((By.ID, 'bGetTimetable'))
            )
            btnClick.click()

            self.browser.switch_to_window(window_name=self.browser.window_handles[-1])

            time.sleep(3)
            with open('out.html', 'w') as file:
                file.write(self.browser.page_source)

        except:
            self.browser.quit()

        # self.browser.quit()
        print('page_loaded')
        os.system("Pause")
