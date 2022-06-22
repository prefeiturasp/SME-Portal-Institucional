using iTextSharp.text.pdf;
using iTextSharp.text.pdf.parser;
using MySql.Data.MySqlClient;
using System.Text;

internal class Class
{
    static void Main(string[] args)
    {
        //Diretório onde os arquivos ".msg" se encontram
        string[] files = Directory.GetFiles(@"C:\\Users\\erik.silva\\Desktop\\Certificados\\");
        Console.WriteLine("Acessando o diretório ...");


        foreach (var file in files)
        {
            Console.WriteLine("Iniciando o Loop em cada arquivo ...");

            using (var msg = new MsgReader.Outlook.Storage.Message(file))
            {
                System.Text.Encoding.RegisterProvider(System.Text.CodePagesEncodingProvider.Instance);
                //Faço uma verificação nos arquivos, se não seguir as regras de nomenclatura, já passo direto.                   
                //Exemplo em que não é encontrado o RF: Curso realizado na SME -_C12017430718_I190679
                //Exemplo em que possuem números com pontuação: Curso realizado na SME -014.261.29_C1HOM21182_I324370


                //Campos que não acessam os Anexos

                var assuntoEmail = msg.Subject;
                var htmlBody = msg.BodyHtml;
                var nomeArquivo = msg.GetAttachmentNames();
                string numHomologacaoCurso = assuntoEmail.Substring(assuntoEmail.Length - 18, 18);
                string rfUsuario = nomeArquivo.Substring(0, 10);

                string connetionString = null;
                connetionString = "server=10.50.1.222;database=sme_certificados;uid=usr_certificados;pwd=WgpxCufo;";

                Console.WriteLine("Conexão ao banco efetuada com sucesso");
                string sql = "SELECT COUNT(*) FROM tb_arquivo_certificado WHERE num_homolog_curso = @num_homolog_curso";
                using (MySqlConnection cn = new MySqlConnection(connetionString))
                {
                    cn.Open();
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

                        //Se for diferente de 36 caracteres (Padrâo) nem efetuo as validações
                        if (nomeArquivo.Length == 36)
                        {
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
                                    int ncTo = textPdf.Replace(" ","").LastIndexOf(" promovido pelo");
                                    string nomeCurso = textPdf.Substring(ncFrom, ncTo - ncFrom);
                                    
                                    //Localizando a data de conclusão
                                    int dcFrom = textPdf.IndexOf("São Paulo, ") + "São Paulo, ".Length;
                                    int dcTo = textPdf.LastIndexOf(".\nPMSP");
                                    string dataConclusaoCurso = textPdf.Substring(dcFrom, dcTo - dcFrom);
                                    dataConclusaoCurso = dataConclusaoCurso.Replace(" de", "/").Replace(" ", "");

                                    //Tratando o mês
                                    dataConclusaoCurso = RetornaMes(dataConclusaoCurso);
                                    //GUID
                                    Guid id = Guid.NewGuid();

                                    //Conectando com o banco de dados
                                    Console.WriteLine("Conectando no banco");

                                    //Preciso verificar se os casos já existem na tabela

                                    using (MySqlCommand cmd = new MySqlCommand(sql, cn))
                                    {
                                        cmd.Parameters.AddWithValue("@num_homolog_curso", numHomologacaoCurso);
                                        var result = Convert.ToInt32(cmd.ExecuteScalar());

                                        //Só vai inserir caso não exista na tabela
                                        if (result == 0)
                                        {
                                            //insert
                                            string queryInsert = "INSERT INTO tb_arquivo_certificado(id,rf,num_homolog_curso,nome_curso,arquivo,dt_conclusao,dt_execucao) VALUES(@id,@rf,@num_homolog_curso,@nome_curso,@arquivo,@dt_conclusao,@dt_execucao)";
                                            using (MySqlCommand cmdInsert = new MySqlCommand(queryInsert, cn))
                                            {
                                                cmdInsert.Parameters.Add("@id", MySqlDbType.VarChar).Value = id;
                                                cmdInsert.Parameters.Add("@rf", MySqlDbType.VarChar).Value = rfUsuario;
                                                cmdInsert.Parameters.Add("@num_homolog_curso", MySqlDbType.VarChar).Value = numHomologacaoCurso;
                                                cmdInsert.Parameters.Add("@nome_curso", MySqlDbType.VarChar).Value = nomeCurso;
                                                cmdInsert.Parameters.Add("@arquivo", MySqlDbType.MediumText).Value = anexo;
                                                cmdInsert.Parameters.Add("@dt_conclusao", MySqlDbType.VarChar).Value = dataConclusaoCurso;
                                                cmdInsert.Parameters.AddWithValue("@dt_execucao", DateTime.Now);
                                                cmdInsert.ExecuteNonQuery();
                                            }


                                        }

                                    }
                                }

                            }
                        }
                    }
                    cn.Close();
                }
            }

        }

        Console.WriteLine("Excluindo pasta!!");

        //Excluindo os arquivos(verificar disponibilidade)
        if (Directory.Exists(@"c:\\temp\\"))
        {
            Directory.Delete(@"c:\\temp\\", true);
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
            case "setembro":
                mesAux = "09";
                break;
            case "outubro":
                mesAux = "10";
                break;
            case "novembro":
                mesAux = "11";
                break;
            case "dezembro":
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