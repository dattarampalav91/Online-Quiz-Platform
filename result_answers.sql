CREATE TABLE IF NOT EXISTS result_answers (
    answer_id INT AUTO_INCREMENT PRIMARY KEY,
    result_id INT NOT NULL,
    question_id INT NOT NULL,
    selected_answer CHAR(1) NULL,
    correct_answer CHAR(1) NOT NULL,
    UNIQUE KEY uq_result_question (result_id, question_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
