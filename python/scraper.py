import time

from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
from selenium.webdriver.chrome.options import Options
from datetime import date

class TimeTable():
    def __init__(self, course_code):
        self.today = date.today()
        self.browser = webdriver.Chrome(options = self.getOptions())
        self.course_code = course_code
        print(f'Processing data for: {self.course_code}')

    def getOptions(self):
        options = Options()
        options.headless = True
        return options

    def today_day(self):
        return str(self.today.strftime("%A"))

    def load_page(self):
        # r = requests.get('https://timetable.ait.ie/2122/login.aspx?ReturnUrl=%2f2122%2fdefault.aspx')
        # print(r.text)
        # self.driver.get("https://timetable.ait.ie/2122/login.aspx?ReturnUrl=%2f2122%2fdefault.aspx")

        self.browser.get("https://timetable.ait.ie/2223/login.aspx?ReturnUrl=%2f2223%2fdefault.aspx")
        # guestLoginBtn = self.browser.find_element_by_id('bGuestLogin')
        guestLoginBtn = self.browser.find_element('id','bGuestLogin')

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

            select_course.select_by_value(self.course_code)

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

            finalOutFileName = (f'{self.course_code}.html')

            with open(finalOutFileName, 'w') as file:
                file.write(self.browser.page_source)

        except:
            self.browser.quit()

        print('Script finished')
        #os.system("Pause")
