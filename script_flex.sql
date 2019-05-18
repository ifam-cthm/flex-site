USE [master]
GO
/****** Object:  Database [flex_ged]    Script Date: 17/05/2019 23:54:59 ******/
CREATE DATABASE [flex_ged]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'flex_ged', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.MSSQLSERVER\MSSQL\DATA\flex_ged.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'flex_ged_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.MSSQLSERVER\MSSQL\DATA\flex_ged_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
GO
ALTER DATABASE [flex_ged] SET COMPATIBILITY_LEVEL = 140
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [flex_ged].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [flex_ged] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [flex_ged] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [flex_ged] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [flex_ged] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [flex_ged] SET ARITHABORT OFF 
GO
ALTER DATABASE [flex_ged] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [flex_ged] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [flex_ged] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [flex_ged] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [flex_ged] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [flex_ged] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [flex_ged] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [flex_ged] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [flex_ged] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [flex_ged] SET  ENABLE_BROKER 
GO
ALTER DATABASE [flex_ged] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [flex_ged] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [flex_ged] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [flex_ged] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [flex_ged] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [flex_ged] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [flex_ged] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [flex_ged] SET RECOVERY FULL 
GO
ALTER DATABASE [flex_ged] SET  MULTI_USER 
GO
ALTER DATABASE [flex_ged] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [flex_ged] SET DB_CHAINING OFF 
GO
ALTER DATABASE [flex_ged] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [flex_ged] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [flex_ged] SET DELAYED_DURABILITY = DISABLED 
GO
EXEC sys.sp_db_vardecimal_storage_format N'flex_ged', N'ON'
GO
ALTER DATABASE [flex_ged] SET QUERY_STORE = OFF
GO
USE [flex_ged]
GO
ALTER DATABASE SCOPED CONFIGURATION SET IDENTITY_CACHE = ON;
GO
ALTER DATABASE SCOPED CONFIGURATION SET LEGACY_CARDINALITY_ESTIMATION = OFF;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET LEGACY_CARDINALITY_ESTIMATION = PRIMARY;
GO
ALTER DATABASE SCOPED CONFIGURATION SET MAXDOP = 0;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET MAXDOP = PRIMARY;
GO
ALTER DATABASE SCOPED CONFIGURATION SET PARAMETER_SNIFFING = ON;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET PARAMETER_SNIFFING = PRIMARY;
GO
ALTER DATABASE SCOPED CONFIGURATION SET QUERY_OPTIMIZER_HOTFIXES = OFF;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET QUERY_OPTIMIZER_HOTFIXES = PRIMARY;
GO
USE [flex_ged]
GO
/****** Object:  Table [dbo].[documento]    Script Date: 17/05/2019 23:54:59 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[documento](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nome] [nvarchar](50) NOT NULL,
	[idSetor] [int] NOT NULL,
	[idTipo] [int] NOT NULL,
	[dataCadastrado] [date] NOT NULL,
	[tag] [int] NULL,
	[dataVencimento] [date] NOT NULL,
	[bloqueado] [bit] NOT NULL,
	[arquivo] [nvarchar](max) NULL,
	[nome_arquivo] [nvarchar](100) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
UNIQUE NONCLUSTERED 
(
	[nome] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[responsavel]    Script Date: 17/05/2019 23:54:59 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[responsavel](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[loginUsuario] [nvarchar](30) NOT NULL,
	[idDocumento] [int] NOT NULL,
	[dateEntrada] [date] NOT NULL,
	[dateSaida] [date] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[setor]    Script Date: 17/05/2019 23:54:59 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[setor](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nome] [nvarchar](30) NOT NULL,
	[bloqueado] [bit] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
UNIQUE NONCLUSTERED 
(
	[nome] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tipo]    Script Date: 17/05/2019 23:55:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tipo](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nome] [nvarchar](30) NOT NULL,
	[descricao] [nvarchar](50) NULL,
	[bloqueado] [bit] NOT NULL,
	[isNotificationEmail] [bit] NULL,
	[isNotificationModal] [bit] NULL,
	[timeNotificationEmail] [int] NULL,
	[timeNotificationModal] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
UNIQUE NONCLUSTERED 
(
	[nome] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[usuario]    Script Date: 17/05/2019 23:55:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[usuario](
	[nome] [varchar](50) NOT NULL,
	[login] [nvarchar](30) NOT NULL,
	[senha] [nvarchar](50) NULL,
	[idSetor] [int] NOT NULL,
	[administrador] [bit] NOT NULL,
	[bloqueado] [bit] NOT NULL,
	[email] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[login] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[documento] ADD  DEFAULT ((0)) FOR [bloqueado]
GO
ALTER TABLE [dbo].[setor] ADD  DEFAULT ((0)) FOR [bloqueado]
GO
ALTER TABLE [dbo].[tipo] ADD  DEFAULT ((0)) FOR [bloqueado]
GO
ALTER TABLE [dbo].[tipo] ADD  DEFAULT ((1)) FOR [isNotificationEmail]
GO
ALTER TABLE [dbo].[tipo] ADD  DEFAULT ((1)) FOR [isNotificationModal]
GO
ALTER TABLE [dbo].[tipo] ADD  DEFAULT ((7)) FOR [timeNotificationEmail]
GO
ALTER TABLE [dbo].[tipo] ADD  DEFAULT ((7)) FOR [timeNotificationModal]
GO
ALTER TABLE [dbo].[usuario] ADD  DEFAULT ((0)) FOR [administrador]
GO
ALTER TABLE [dbo].[usuario] ADD  DEFAULT ((0)) FOR [bloqueado]
GO
ALTER TABLE [dbo].[documento]  WITH CHECK ADD FOREIGN KEY([idSetor])
REFERENCES [dbo].[setor] ([id])
GO
ALTER TABLE [dbo].[documento]  WITH CHECK ADD FOREIGN KEY([idTipo])
REFERENCES [dbo].[tipo] ([id])
GO
ALTER TABLE [dbo].[responsavel]  WITH CHECK ADD FOREIGN KEY([idDocumento])
REFERENCES [dbo].[documento] ([id])
GO
ALTER TABLE [dbo].[responsavel]  WITH CHECK ADD FOREIGN KEY([loginUsuario])
REFERENCES [dbo].[usuario] ([login])
GO
ALTER TABLE [dbo].[usuario]  WITH CHECK ADD FOREIGN KEY([idSetor])
REFERENCES [dbo].[setor] ([id])
GO
/****** Object:  StoredProcedure [dbo].[documentosEncontrados]    Script Date: 17/05/2019 23:55:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
/**
	author: Pedro Pequeno
	date: 16/01/2019
	updated: 16/01/2019
**/
CREATE PROCEDURE [dbo].[documentosEncontrados] 
@NOME NVARCHAR(50)= '',
@SETORINICIO NVARCHAR(30) = '  ',
@SETORFINAL NVARCHAR(30) = 'ZZZZ',
@TIPOINICIO NVARCHAR(30) = '  ',
@TIPOFINAL NVARCHAR(30) = 'ZZZZ',
@RESPONSAVELINICIO NVARCHAR(30) = '  ',
@RESPONSAVELFINAL NVARCHAR(30) = 'ZZZZ'
AS
BEGIN
IF @NOME = ''
SELECT * FROM (
		SELECT 
		d.id, d.nome, d.nome_arquivo, d.arquivo, CONVERT(NVARCHAR, d.dataCadastrado,103) as cadastrado, 
		CONVERT(NVARCHAR, d.dataVencimento, 103) vencimento, 
		d.bloqueado, s.nome as setor, t.nome as tipo, u.nome as responsavel
		FROM (SELECT * FROM documento WHERE bloqueado = 0) d 
			INNER JOIN setor s ON s.id = d.idSetor 
			INNER JOIN tipo t on t.id = d.idTipo
			INNER JOIN responsavel r on r.idDocumento = d.id
			INNER JOIN usuario u on r.loginUsuario = u.login
			WHERE r.dateSaida IS NULL) AS documentos 
	WHERE
		documentos.setor BETWEEN @SETORINICIO AND @SETORFINAL AND
		documentos.tipo BETWEEN @TIPOINICIO AND @TIPOFINAL AND
		documentos.responsavel BETWEEN @RESPONSAVELINICIO AND @RESPONSAVELFINAL
ELSE
	SELECT * FROM (
		SELECT 
		d.id, d.nome, d.arquivo, CONVERT(NVARCHAR, d.dataCadastrado,103) as cadastrado, 
		CONVERT(NVARCHAR, d.dataVencimento, 103) vencimento, 
		d.bloqueado, s.nome as setor, t.nome as tipo, u.nome as responsavel
		FROM (SELECT * FROM documento WHERE bloqueado = 0 AND nome LIKE '%'+@NOME+'%') d 
			INNER JOIN setor s ON s.id = d.idSetor 
			INNER JOIN tipo t on t.id = d.idTipo
			INNER JOIN responsavel r on r.idDocumento = d.id
			INNER JOIN usuario u on r.loginUsuario = u.login
			WHERE r.dateSaida IS NULL) AS documentos 
	WHERE
		documentos.setor BETWEEN @SETORINICIO AND @SETORFINAL AND
		documentos.tipo BETWEEN @TIPOINICIO AND @TIPOFINAL AND
		documentos.responsavel BETWEEN @RESPONSAVELINICIO AND @RESPONSAVELFINAL
END 
GO
/****** Object:  StoredProcedure [dbo].[documentosVencidos]    Script Date: 17/05/2019 23:55:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
/**
	author: Pedro Pequeno
	date: 11/01/2019
	updated: 11/01/2019
**/
CREATE PROCEDURE [dbo].[documentosVencidos] 
@DTVALIDADE NVARCHAR(10),
@DIFERENCA INT, 
@SETORINICIO NVARCHAR(30) = '  ',
@SETORFINAL NVARCHAR(30) = 'ZZZZ',
@TIPOINICIO NVARCHAR(30) = '  ',
@TIPOFINAL NVARCHAR(30) = 'ZZZZ',
@RESPONSAVELINICIO NVARCHAR(30) = '  ',
@RESPONSAVELFINAL NVARCHAR(30) = 'ZZZZ'
AS
BEGIN
	SELECT * FROM (
		SELECT 
		d.id, d.nome, d.nome_arquivo, d.arquivo, CONVERT(NVARCHAR, d.dataCadastrado,103) as cadastrado, 
		CONVERT(NVARCHAR, d.dataVencimento, 103) vencimento, 
		d.bloqueado, s.nome as setor, t.nome as tipo, u.nome as responsavel
		FROM (SELECT * FROM documento WHERE dataVencimento >= CONVERT(DATE, @DTVALIDADE, 103) 
		AND bloqueado = 0 AND
		DATEDIFF(day, CONVERT(DATE, @DTVALIDADE, 103), dataVencimento) <= @DIFERENCA) d 
			INNER JOIN setor s ON s.id = d.idSetor 
			INNER JOIN tipo t on t.id = d.idTipo
			INNER JOIN responsavel r on r.idDocumento = d.id
			INNER JOIN usuario u on r.loginUsuario = u.login
			WHERE r.dateSaida IS NULL) AS documentos 
	WHERE
		documentos.setor BETWEEN @SETORINICIO AND @SETORFINAL AND
		documentos.tipo BETWEEN @TIPOINICIO AND @TIPOFINAL AND
		documentos.responsavel BETWEEN @RESPONSAVELINICIO AND @RESPONSAVELFINAL
END 
GO
/****** Object:  StoredProcedure [dbo].[inicializarBanco]    Script Date: 17/05/2019 23:55:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[inicializarBanco]
AS
INSERT INTO setor (nome)
VALUES ('administrativo'),('financeiro'), ('recursos humanos'), 
	('comercial'), ('operacional'), ('TI'), ('qualidade');
GO
USE [master]
GO
ALTER DATABASE [flex_ged] SET  READ_WRITE 
GO
