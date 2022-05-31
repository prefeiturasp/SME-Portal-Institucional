using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Mail;
using System.Text;
using System.IO;
using Microsoft.Office.Interop.Outlook;
using System.Data.SqlClient;
using iTextSharp.text.pdf;
using iTextSharp.text.pdf.parser;
using System.Data;

namespace POC_Ler_Dados
{
    internal class Program
    {
        static void Main(string[] args)
        {
            //Diretório onde os arquivos ".msg" se encontram
            string[] files = Directory.GetFiles(@"C:\\Users\\erik.silva\\Desktop\\Certificados\\Certificados\\");
            Console.WriteLine("Acessando o diretório ...");


            foreach (var file in files)
            {
                Console.WriteLine("Iniciando o Loop em cada arquivo ...");

                using (var msg = new MsgReader.Outlook.Storage.Message(file))
                {
                    //Campos que não acessam os Anexos
                    var emailDestinatario = msg.GetEmailRecipients(MsgReader.Outlook.RecipientType.To, false, false);
                    var assuntoEmail = msg.Subject;
                    var htmlBody = msg.BodyHtml;
                    var nomeArquivo = msg.GetAttachmentNames();
                    string numHomologacaoCurso = assuntoEmail.Substring(assuntoEmail.Length - 18, 18);
                    string rfUsuario = nomeArquivo.Substring(0, 10);

                    //lendo os sAnexos
                    foreach (MsgReader.Outlook.Storage.Attachment itmAttachment in msg.Attachments)
                    {

                        //Convertendo para base 64
                        var oData = itmAttachment.Data;
                        var anexo = Convert.ToBase64String(oData);

                        //Se não existir, crio a pasta temp para armazenar os anexos
                        string caminhoArquivo = @"c:\\temp\\";

                        if (!Directory.Exists(caminhoArquivo))
                        {
                            Directory.CreateDirectory(caminhoArquivo);
                        }

                        caminhoArquivo = caminhoArquivo + nomeArquivo;

                        //Jogando de BASE64 para arquivos, para ler o conteúdo do PDF anexo
                        using (System.IO.FileStream stream = System.IO.File.Create(caminhoArquivo))
                        {
                            System.Byte[] byteArray = System.Convert.FromBase64String(anexo);
                            stream.Write(byteArray, 0, byteArray.Length);
                        }

                        //Iniciando a leitura dos arquivos
                        using (PdfReader reader = new PdfReader(caminhoArquivo))
                        {
                            for (int pageNo = 1; pageNo <= reader.NumberOfPages; pageNo++)
                            {
                                ITextExtractionStrategy strategy = new SimpleTextExtractionStrategy();
                                string textPdf = PdfTextExtractor.GetTextFromPage(reader, pageNo, strategy);
                                textPdf = Encoding.UTF8.GetString(ASCIIEncoding.Convert(Encoding.Default, Encoding.UTF8, Encoding.Default.GetBytes(textPdf)));

                                //Localizando o nome do curso
                                int ncFrom = textPdf.IndexOf("Curso ") + "Curso ".Length;
                                int ncTo = textPdf.LastIndexOf(" promovido");
                                string nomeCurso = textPdf.Substring(ncFrom, ncTo - ncFrom);


                                //Localizando a data de conclusão
                                int dcFrom = textPdf.IndexOf("São Paulo, ") + "São Paulo, ".Length;
                                int dcTo = textPdf.LastIndexOf(".\nPMSP");
                                string dataConclusaoCurso = textPdf.Substring(dcFrom, dcTo - dcFrom);


                                dataConclusaoCurso = dataConclusaoCurso.Replace(" de", "/").Replace(" ", "");


                                //Tratando o mês
                                dataConclusaoCurso = RetornaMes(dataConclusaoCurso);

                                //Conectando com o banco de dados
                                Console.WriteLine("Conectando no bancos");

                                string connectionString = "Data Source=localhost\\SQLEXPRESS;Database=Comunicacao;Integrated Security=true";
                                SqlConnection conn = new SqlConnection(connectionString);
                                conn.Open();

                                Console.WriteLine("Conexão ao banco efetuada com sucesso");

                                //inserindo as informações no banco

                                Guid id = Guid.NewGuid();

                                String query = "INSERT INTO tb_arquivo_certificado VALUES(@id, @nome_arquivo, @nome_curso, @num_homologacao_curso, @assunto_email, @rf_usuario, @email_destinatario, @anexo, @data_conclusao_curso, @data_leitura)";
                                using (SqlConnection connection = new SqlConnection(connectionString))
                                using (SqlCommand command = new SqlCommand(query, connection))
                                {

                                    command.Parameters.Add("@id", SqlDbType.UniqueIdentifier).Value = id;
                                    command.Parameters.Add("@nome_arquivo", SqlDbType.VarChar).Value = nomeArquivo;
                                    command.Parameters.Add("@nome_curso", SqlDbType.VarChar).Value = nomeCurso;
                                    command.Parameters.Add("@num_homologacao_curso", SqlDbType.VarChar).Value = numHomologacaoCurso;
                                    command.Parameters.Add("@assunto_email", SqlDbType.VarChar).Value = assuntoEmail;
                                    command.Parameters.Add("@rf_usuario", SqlDbType.VarChar).Value = rfUsuario;
                                    command.Parameters.Add("@email_destinatario", SqlDbType.VarChar).Value = emailDestinatario;
                                    command.Parameters.Add("@data_conclusao_curso", SqlDbType.VarChar).Value = dataConclusaoCurso;
                                    command.Parameters.Add("@anexo", SqlDbType.VarChar).Value = anexo;
                                    command.Parameters.Add("@data_leitura", SqlDbType.Date).Value = DateTime.Now;

                                    connection.Open();
                                    command.ExecuteNonQuery();
                                }

                            }
                        }

                    }
                }

            }

            Console.WriteLine("Excluindo pasta!!");

            //Excluindo os arquivos(verificar disponibilidade)
            if (Directory.Exists(@"c:\\temp\\"))
            {
                Directory.Delete(@"c:\\temp\\",true);
            }

            Console.WriteLine("Fim do processo!!");
            Console.Read();
        }

        public static string RetornaMes(string data)
        {
            //Quebrando as datas
            string dataTratada = "";
            string mesAux = "";

            //Dia
            string dia = data.Split('/')[0];

            //Mês
            int mesFrom = data.IndexOf("/") + "/".Length;
            int mesTo = data.LastIndexOf("/");
            string mes = data.Substring(mesFrom, mesTo - mesFrom);

            //Ano
            string ano = data.Split('/')[2];

            switch (mes)
            {
                case "janeiro":
                    mesAux = "01";
                    break;
                case "fevereiro":
                    mesAux = "02";
                    break;
                case "março":
                    mesAux = "03";
                    break;
                case "abril":
                    mesAux = "04";
                    break;
                case "maio":
                    mesAux = "05";
                    break;
                case "junho":
                    mesAux = "06";
                    break;
                case "julho":
                    mesAux = "07";
                    break;
                case "agosto":
                    mesAux = "08";
                    break;
                case "Setembro":
                    mesAux = "09";
                    break;
                case "Outubro":
                    mesAux = "10";
                    break;
                case "Novembro":
                    mesAux = "11";
                    break;
                case "Dezembro":
                    mesAux = "12";
                    break;
                default:
                    Console.Write("Mês inválido....\n");
                    break;
            }

            dataTratada = dia + "/" + mesAux + "/" + ano;

            return dataTratada;
        }

    }

}

