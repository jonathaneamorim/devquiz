
CREATE TABLE `teste`.usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    isAdmin BOOLEAN DEFAULT FALSE
);


CREATE TABLE `teste`.quiz (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    criadoPor INT NOT NULL,
    criadoEm DATETIME DEFAULT CURRENT_TIMESTAMP,
    imagemAssociada LONGTEXT,
    FOREIGN KEY (criadoPor) REFERENCES usuario(id) ON DELETE CASCADE
);

-- Tabela de perguntas
CREATE TABLE `teste`.pergunta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    texto TEXT NOT NULL,
    quiz_id INT NOT NULL,
    resposta_certa_id INT,
    FOREIGN KEY (quiz_id) REFERENCES quiz(id) ON DELETE CASCADE
);

-- Tabela de respostas
CREATE TABLE `teste`.resposta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    texto TEXT NOT NULL,
    pergunta_id INT NOT NULL,
    FOREIGN KEY (pergunta_id) REFERENCES pergunta(id) ON DELETE CASCADE
);

-- Define a resposta correta após as respostas existirem
ALTER TABLE `teste`.pergunta
ADD CONSTRAINT fk_resposta_certa
FOREIGN KEY (resposta_certa_id) REFERENCES resposta(id) ON DELETE SET NULL;

-- Tabela de pontuação do usuário (PointBoard)
CREATE TABLE `teste`.tabelaPontuacao (
    usuarioId INT NOT NULL,
    quizId INT NOT NULL,
    acertos INT NOT NULL,
    total INT NOT NULL,
    porcentagemAcertos DECIMAL(5,2) GENERATED ALWAYS AS (acertos / total * 100) STORED,
    ultimaVezRespondido DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (usuarioId, quizId),
    FOREIGN KEY (usuarioId) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (quizId) REFERENCES quiz(id) ON DELETE CASCADE
);
