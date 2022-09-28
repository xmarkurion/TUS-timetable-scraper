BIN=.venv/Scripts/

run:
	$(BIN)python main.py
	rd /s /q __pycache__
	
rd:
	rd /s /q __pycache__
	rd /s /q venv
	rd /s /q .venv
	rd *.html

fix:
	rd /s /q .venv
	python -m venv .venv
	$(BIN)pip install -r requriments.txt 
	$(BIN)pip freeze


	

