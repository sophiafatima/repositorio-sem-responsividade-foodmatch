create database FoodMatch;
use FoodMatch;

create table Usuario(
id_usuario int not null auto_increment primary key,
nome_usuario varchar(500) not null,
email_usuario varchar(500) not null,
senha_usuario varchar(500) not null,
idioma bool
) engine = InnoDB;

create table Receitas(
id_receita int not null auto_increment primary key,
nome_receita varchar(500) not null,
descricao_receita varchar(500) not null,
preferencias varchar(500),
restricao bool,
ingredientes varchar(500)
) engine = InnoDB;

create table Post(
id_post int not null auto_increment primary key,
titulo_post varchar(200) not null,
descricao_post varchar(500) not null,
nome_usuario varchar(500),
id_usuario int not null,
foreign key (id_usuario) references Usuario (id_usuario)
) engine = InnoDB;

create table Avaliacao(
id_avaliacao int not null auto_increment primary key,
id_usuario int not null,
nota int,
comentario varchar(500),
nome_usuario varchar(500),
foreign key (id_usuario) references Usuario (id_usuario)
) engine = InnoDB;

create table ReceitaSalva(
id_receita int not null,
id_usuario int not null,
nome_receita varchar(500),
descricao_receita varchar(500),
foreign key (id_receita) references Receitas (id_receita),
foreign key (id_usuario) references Usuario (id_usuario)
) engine = InnoDB;

create table ListaDeCompras(
id_receita int not null,
recomendacao varchar(500),
ingredientes varchar(500),
foreign key (id_receita) references Receitas (id_receita)
) engine = InnoDB;


insert into Post (nome_usuario) select nome_usuario from Usuario;
insert into Avaliacao (nome_usuario) select nome_usuario from Usuario;
insert into ReceitaSalva (nome_receita, descricao_receita) select nome_receita, descricao_receita from Receitas;
insert into ListaDeCompras (ingredientes) select ingredientes from Receitas;
